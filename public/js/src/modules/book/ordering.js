import pagination from '../../shared/pagination'

export default (() => {
  const $dom = {}

  function _cacheDom() {
    $dom.root = $('#book-list')
    $dom.ordering = $('.book-ordering')
    _cacheBook()
  }

  function _cacheBook() {
    $dom.books = $dom.root.children()
  }

  function _bindEvents() {
    $dom.ordering.on('change', _handleOrderingChange)
  }

  function _handleOrderingChange(event) {
    event.preventDefault()
    const value = $(event.target).val()
    const [prop, order] = value.split('-')
    const $sortedBooks = _getSortedDomElements(prop, order)
    _render($sortedBooks)
  }

  function _render($books) {
    $dom.root.append($books)

    const visible = pagination.countVisible()

    $dom.root.children().each((index, element) => {
      if (index > visible - 1) {
        $(element).hide()
      } else {
        $(element).show()
      }
    })

    _renderEffects()
  }

  function _renderEffects() {
    _cacheBook()
  }

  function _getSortedDomElements(prop, order = 'asc') {
    console.log(prop, order)
    const desc = order === 'desc'
    return $dom.books.sort((current, next) => {
      const currentData = $(current).data()
      const nextData = $(next).data()
      if (currentData[prop] < nextData[prop]) {
        return desc ? 1 : -1
      }
      if (currentData[prop] > nextData[prop]) {
        return desc ? -1 : 1
      }
      return 0
    })
  }

  return {
    init() {
      _cacheDom()
      _bindEvents()
      _renderEffects()
    }
  }
})()
