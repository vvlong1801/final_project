import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { useToast } from "primevue/usetoast";
import { useRouter } from "vue-router";
export const useChallenge = defineStore("challenge", () => {
  const router = useRouter();
  const challenges = ref([]);
  const challengeTypes = ref([]);
  const filtered = ref([]);
  const toast = useToast();
  const findedChallenge = ref({});

  const form = reactive({
    name: "",
    type: null,
    status: "",
    exercises: [],
    description: "",
    image: null,
  });

  const fillForm = (data) => {
    form.name = data.name;
    form.type = data.type;
    form.status = data.status;
    form.exercises = data.exercises;
    form.description = data.description;
    form.image = data.image;
  };

  const resetFindedChallenge = () => (findedChallenge.value = null);
  const resetForm = () => {
    form.name = "";
    form.type = "";
    form.status = "";
    form.exercises = [];
    form.description = "";
    form.image = null;
  };

  const showToast = (type = "success", title = "Success", content = "") => {
    toast.add({
      severity: type,
      summary: title,
      detail: content,
      life: 3000,
    });
  };

  const getChallenges = () => {
    return window.axios
      .get("challenges")
      .then((res) => {
        challenges.value = res.data;
      })
      .catch((err) => {});
  };

  const getChallengeTypes = () => {
    return window.axios
      .get("challenges/types")
      .then((res) => {
        challengeTypes.value = res.data;
      })
      .catch((err) => {
        showToast("error", err.response.data.message);
      });
  };

  const getChallengeById = (id) => {
    return window.axios
      .get(`challenges/find/${id}`)
      .then((res) => {
        findedChallenge.value = res.data;
      })
      .catch((err) => {
        showToast("error", err.response.data.message);
      });
  };

  const createChallenge = () => {
    form.exercises = form.exercises.map((item) => item.id);

    window.axios
      .post("challenges", form)
      .then((res) => {
        showToast("success", res.message);
        router.push({ name: "challenges.index" });
        resetForm();
      })
      .catch((err) => {
        showToast("error", err.response.data.message);
      });
  };

  const editChallenge = (id) => {
    form.exercises = form.exercises.map((item) => item.id);

    window.axios
      .put(`challenges/${id}`, form)
      .then((res) => {
        showToast("success", res.message);
        router.push({ name: "challenges.index" });
        resetFindedChallenge();
        resetForm();
      })
      .catch((err) => {
        showToast("error", err.response.data.message);
      });
  };
  const deleteChallenge = (id) => {
    window.axios
      .delete(`challenges/${id}`)
      .then((res) => {
        showToast("success", res.message);
        getChallenges();
      })
      .catch((err) => {
        showToast("error", err.response.data.message);
      });
  };

  return {
    challenges,
    challengeTypes,
    form,
    fillForm,
    resetForm,
    filtered,
    getChallenges,
    getChallengeTypes,
    getChallengeById,
    findedChallenge,
    createChallenge,
    editChallenge,
    deleteChallenge,
  };
});
