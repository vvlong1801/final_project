<?php

namespace App\Services;

use App\Enums\StatusChallenge;
use App\Models\Challenge;
use App\Models\ChallengePhase;
use App\Models\ExerciseRequirement;
use App\Models\SessionExercise;
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
            // dd($challenge->created_by);

            $challenge->image()->save($payload['image']);

            $phases = \Arr::get($payload, 'phases', []);

            $this->createChallengePhase($challenge, $phases);

            \DB::commit();
            return true;
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

    private function createChallengePhase(Challenge $challenge, array $payload)
    {
        if (!count($payload)) throw new \Exception("challenge hasn't phases", 1);

        $result = [];

        foreach ($payload as $index => $data) {
            // dd($phase);
            $newPhase = new ChallengePhase(\Arr::only($data, [
                'name', 'level', 'description',
                'min_rank', 'max_rank', 'active_days', 'rest_days'
            ]));
            $newPhase->order = $index;
            $newPhase->count_sessions =
                count(\Arr::get($data, 'sessions', null)) ?? throw new \Exception("Hasn't workout session in the phase", 1);
            $challenge->phases()->save($newPhase);

            $this->createSessions($newPhase, $data['sessions']);
            dd($newPhase);
            \Arr::add($result, $index, $newPhase);
        }

        return $result;
    }

    private function createSessions(ChallengePhase $phase, $sessions)
    {
        // if (!count($sessions)) throw new \Exception("the phase hasn't sessions", 1);

        $collectSessions = collect([]);
        foreach ($sessions as $index => $session) {
            $newSession = $phase->sessions()->create(['name' => 'day ' . $index, 'order' => $index]);
            // $collectExercises = collect([]);
            foreach ($session as $key => $exercise) {
                $ssExercise = $newSession->exercises()->newPivot(['order' => $key, 'is_primary' => true, 'exercise_id' => $exercise['exercise_id']]);
                $requires = collect([]);

                foreach ($exercise['requirement'] as $k => $req) {
                    $param = $req['param'];
                    $data = \Arr::where(config('constant.param_requirement'), fn ($value, $key) => $key === $param);

                    $newReq = new ExerciseRequirement([
                        'param' => $param,
                        'param_type' => $data[$param]['type'],
                        'unit' => $data[$param]['unit'],
                        'value' => $req['value'],
                        'order' => $k,
                    ]);
                    $requires->push($newReq);
                }

                $ssExercise->requirements()->createMany($requires->toArray());
                dd($ssExercise);
                // $collectExercises->push($ssExercise);
            }

            dd($data);
            $data->exercises()->attach();
            \Arr::add($collectSessions, $index, $data);
        }
        return $collectSessions;
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
