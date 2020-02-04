const allowedMethods = ['html', 'append', 'prepend']

export default class View {
  constructor(getHTML) {
    this.getHTML = getHTML
  }

  static validateRenderMethod(method) {
    if (!allowedMethods.includes(method)) {
      throw new Error('Invalid render method')
    }
  }

  render(item, selector, method = 'html') {
    View.validateRenderMethod(method)
    $(selector)[method](this.getHTML(item))
  }

  renderList(items, selector, method = 'html') {
    View.validateRenderMethod(method)
    $(selector)[method](items.map(this.getHTML).join(''))
  }
}
