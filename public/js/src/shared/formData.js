export default $from => {
  const data = {}
  $from.find('input, textarea').each((i, el) => {
    data[el.name] = el.value
  })
  return data
}
