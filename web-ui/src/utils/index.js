export function readFile(file) {
  const reader = new FileReader();

  reader.onload = function (event) {
    const content = event.target.result;
    console.log(content);
  };

  reader.readAsText(file);
}
