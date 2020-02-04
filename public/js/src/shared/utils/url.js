export default {
  getParams() {
    const search = location.search.substring(1)
    try {
      return JSON.parse(
        '{"' +
          decodeURI(search)
            .replace(/"/g, '\\"')
            .replace(/&/g, '","')
            .replace(/=/g, '":"') +
          '"}'
      )
    } catch {
      return {}
    }
  },
  getParam(param) {
    return this.getParams()[param]
  }
}
