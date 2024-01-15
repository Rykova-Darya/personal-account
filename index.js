async function sendHttpRequest(url, formData) {
  console.log(formData);
  let data;

  let response = await fetch(url, {
    method: "POST",
    body: formData,
  });

  try {
    data = await response.json();
  } catch (jsonError) {
    console.error(`Ошибка HTTP: ${response.status}`);
  }

  if (!response.ok) {
    throw new Error(data?.message || "Ошибка запроса");
  }

  return data;
}

async function sendSimpleHttpRequest(url, data) {
  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    });

    if (!response.ok) {
      throw new Error(`Ошибка HTTP: ${response.status}`);
    }

    const responseData = await response.json();
    return responseData;
  } catch (error) {
    console.error("Ошибка при отправке данных на сервер:", error);
  }
}

// Функции валидации формы
function displayError(errorId, errorMessage) {
  let errorElement = document.getElementById(errorId);
  if (errorElement) {
    errorElement.textContent = errorMessage;
  }
}

function clearError(errorId) {
  let errorElement = document.getElementById(errorId);
  if (errorElement) {
    errorElement.textContent = "";
  }
}

function clearErrorOnInput(event) {
  console.log('очистили');
  let errorId = event.target.id + "-error";
  clearError(errorId);
  removeErrorClass(event.target);
}

function addErrorClass(inputElement) {
  inputElement.classList.add("error-input");
}

function removeErrorClass(inputElement) {
  inputElement.classList.remove("error-input");
}

function downloadFile(file_path) {
  let downloadLink = document.createElement("a");
  downloadLink.href = "./download_files/" + file_path;
  downloadLink.download = "./download_files/" + file_path;
  downloadLink.click();
}
