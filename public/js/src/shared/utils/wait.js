export default (data, time = 0) =>
  new Promise(resolve => {
    setTimeout(() => {
      resolve(data)
    }, time)
  })
