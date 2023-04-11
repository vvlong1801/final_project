const exerciseTypes = [
  {
    label: "Repitition",
    value: "repitition",
    icon: "pi-bolt",
  },
  {
    label: "Time-based",
    value: "timeBased",
    icon: "pi-clock",
  },
  {
    label: "Distance-based",
    value: "distanceBased",
    icon: "pi-arrows-h",
  },
];
const levelTypes = [
  { label: "Easy", value: "easy", severity: "success" },
  { label: "Middle", value: "middle", severity: "primary" },
  { label: "Hard", value: "hard", severity: "danger" },
];
const status = [
  { label: "Active", value: "active" },
  { label: "Disabled", value: "disabled" },
];

function getOption(optionData, value) {
  const option = optionData.filter((item) => item.value == value);
  return option[0];
}

function getLabel(optionData, value) {
  const option = getOption(optionData, value);
  return option.label;
}

function getIcon(optionData, value) {
  if (optionData[0].hasOwnProperty("icon")) {
    const option = getOption(optionData, value);
    return option.icon;
  }
  return null;
}

function getSeverity(optionData, value) {
  if (optionData[0].hasOwnProperty("severity")) {
    const option = getOption(optionData, value);
    return option.severity;
  }
  return null;
}

export {
  exerciseTypes,
  levelTypes,
  status,
  getOption,
  getIcon,
  getLabel,
  getSeverity,
};
