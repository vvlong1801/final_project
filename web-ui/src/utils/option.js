const EVALUATE_METHOD = {
  repitition: {
    label: "Repitition",
    value: "repitition",
    icon: "pi-bolt",
  },
  timeBased: {
    label: "Time-based",
    value: "timeBased",
    icon: "pi-clock",
  },
  distanceBased: {
    label: "Distance-based",
    value: "distanceBased",
    icon: "pi-arrows-h",
  },
};

const TYPE_LEVEL = {
  easy: { label: "Easy", value: "easy", severity: "success" },
  middle: { label: "Middle", value: "middle", severity: "primary" },
  hard: { label: "Hard", value: "hard", severity: "danger" },
};

const STATUS = {
  active: { label: "Active", value: "active" },
  disabled: { label: "Disabled", value: "disabled" },
};

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
  EVALUATE_METHOD,
  TYPE_LEVEL,
  STATUS,
  getOption,
  getIcon,
  getLabel,
  getSeverity,
};
