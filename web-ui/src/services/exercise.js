export const onGetExercises = async () => {
  const result = await window.axios.get("exercises");
  return result.data;
};

export const onGetExercisesWithPagination = async (pageNum = 1) => {
  const result = await window.axios.get(`exercises/12?page=${pageNum}`);
  return result.data;
};

export const getExerciseById = async (id) => {
  await window.axios
    .get(`exercises/find/${id}`)
    .then((res) => {
      editItem.value = convertResToData(res.data);
    })
    .catch((err) => {
      showToast("error", err.response.data.message);
    });
};

export const createExercise = async (data) => {
  const result = await window.axios.post("exercises", data);
  return result.data;
};

export const editExercise = async (id, data) => {
  const result = await window.axios.put(`exercises/${id}`, data);
  return result.data;
};

export const deleteExercise = async (ids) => {
  const result = await window.axios.post("exercises/delete", { ids });
  return result.data;
};
