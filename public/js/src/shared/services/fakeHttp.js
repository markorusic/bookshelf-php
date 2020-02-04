const fakeRequest = (...args) =>
  new Promise(resolve => {
    setTimeout(() => {
      resolve(...args)
    }, 500)
  })

export default {
  get: fakeRequest,
  post: fakeRequest,
  put: fakeRequest,
  delete: fakeRequest
}
