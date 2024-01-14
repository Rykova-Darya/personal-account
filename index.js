// async function sendHttpRequest(url, formData) {
//   console.log(formData);
//   let response = await fetch(url, {
//     method: "POST",
//     body: formData,
//   });
//   let data = await response.json();
//     if (!response.ok) {
//     throw new Error(data.message || 'Ошибка запроса');
//   }
//   return data;
// }

async function sendHttpRequest(url, formData) {
  console.log(formData);
  let data; // Переменная в области видимости функции

  let response = await fetch(url, {
    method: "POST",
    body: formData,
  });

  try {
    data = await response.json();
  } catch (jsonError) {
    console.error(`Ошибка HTTP: ${response.status}`);
    // Обработка ошибки JSON парсинга
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
        "Content-Type": "application/json", // Укажите правильный Content-Type
      },
      body: JSON.stringify(data), // Преобразуйте объект в JSON
    });

    if (!response.ok) {
      throw new Error(`Ошибка HTTP: ${response.status}`);
    }

    const responseData = await response.json();
    return responseData;
  } catch (error) {
    console.error("Ошибка при отправке данных на сервер:", error);
    // Обработайте ошибку по вашему усмотрению
  }
}
