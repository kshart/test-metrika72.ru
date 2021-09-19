import Case from 'case'

const convertToSnake = (obj) => {
  const newObj = {}
  for (const paramName in obj) {
    newObj[Case.snake(paramName)] = obj[paramName]
  }
  return newObj
}

export default {
  send (form) {
    return fetch('/api/create-feedback', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(convertToSnake(form))
    })
      .then((response) => {
        if (!response.ok) {
          if (response.status === 409) {
            const error = new Error('Ошибка при отправке запроса')
            error.isUniqueError = true
            throw error
          }
          throw new Error('Ошибка при отправке запроса')
        }
        return response
      })
  }
}
