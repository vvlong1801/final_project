<?php

namespace App\Services;

use App\Enums\StatusChallenge;
use App\Models\Challenge;
use App\Models\ChallengePhase;
use App\Models\WorkoutSession;
use App\Services\Interfaces\ChallengeServiceInterface;
use Illuminate\Support\Arr;

class ChallengeService extends BaseService implements ChallengeServiceInterface
{
    public function getChallenges()
    {
        return Challenge::with(['type', 'image'])->withCount('exercises')->get();
    }

    public function getChallengeById($id)
    {
        $challenge = Challenge::with(['type', 'image'])->withCount('exercises')->whereId($id)->first();
        return $challenge;
    }

    public function createChallenge(array $payload)
    {

        \DB::beginTransaction();
        try {
            $challenge = new Challenge(\Arr::only($payload, [
                'name', 'description', 'type', 'max_member',
                'commit_point', 'participant', 'required_approve',
                'member_censorship', 'result_censorship',
                'released_at', 'finished_at'
            ]));
            $challenge->status = StatusChallenge::init;
            $challenge->save();
            $challenge->image()->save($payload['image']);
            $challenge->phases()->saveMany($this->createChallengePhase(\Arr::get($payload, 'phases', [])));
            \DB::commit();
            return true;
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

    private function createChallengePhase($phases)
    {
        if (count($phases)) throw new \Exception("challenge hasn't phases", 1);

        $result = [];
        foreach ($phases as $index => $phase) {
            $data = new ChallengePhase(\Arr::only($phase, [
                'name', 'level', 'description',
                'min_rank', 'max_rank', 'active_days', 'rest_days'
            ]));
            $data->order = $index;
            $data->count_sessions = count(\Arr::get($phase, 'sessions', null)) ?? throw new \Exception("Hasn't workout session in the phase", 1);
            \Arr::add($result, $index, $data);
        }
        return $result;
    }

    private function createSessions($sessions)
    {
        if (count($sessions)) throw new \Exception("the phase hasn't sessions", 1);

        $result = [];
        foreach ($sessions as $index => $session) {
            $data = new WorkoutSession(['name' => 'day ' . $index, 'order' => $index]);
            $data->exercises()->attach();
            \Arr::add($result, $index, $data);
        }
        return $result;
    }

    public function updateChallenge($id, array $payload)
    {
        $challenge = Challenge::find($id);
        $payload['type_id'] = \Arr::get($payload, 'type', 0);
        $challenge->update(\Arr::only($payload, ['name', 'type_id', 'description']));

        if ($payload['image']) $challenge->image()->update($payload['image']->getAttributes());
        $challenge->exercises()->sync(\Arr::get($payload, 'exercises', []));

        return $challenge->loadCount('exercises');
    }

    public function deleteChallenge($id)
    {
        $result = Challenge::where('id', $id)->delete();
        if (!$result) throw new \Exception("delete is error");
    }
}
