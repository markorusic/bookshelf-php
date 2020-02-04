export default (() => {
  const SHOW_PER_CLICK = 8

  const $dom = {
    loadMore: null,
    all: null,
    hidden: null,
    counter: null,
    api: {
      refreshAll() {
        $dom.all = $('[data-pageable]')
      },
      refreshHidden() {
        $dom.hidden = $('[data-pageable]:hidden')
      }
    }
  }

  function _cacheDom() {
    $dom.loadMore = $('#loadMore')
    $dom.loadMoreWrapper = $dom.loadMore.parent().parent()
    $dom.counter = $('.currently-showing')
    $dom.counterTotal = $('.total')
    $dom.api.refreshAll()
    $dom.api.refreshHidden()
  }

  function _bindEvents() {
    $dom.loadMore.on('click', _handleShowMore)
  }

  function _handleShowMore(event) {
    $dom.api.refreshHidden()
    event.preventDefault()
    $dom.hidden.slice(0, SHOW_PER_CLICK).slideDown()
    $dom.api.refreshHidden()
    if ($dom.hidden.length <= 0) {
      $dom.loadMoreWrapper.hide()
    }
    _updateCounter()
  }

  function _updateCounter() {
    if ($dom.counter.length > 0) {
      $dom.counter.text($dom.all.length - $dom.hidden.length)
      $dom.counterTotal.text($dom.all.length)
    }
  }

  return {
    init() {
      _cacheDom()
      _bindEvents()
      _updateCounter()
      if ($dom.hidden.length > 0) {
        $dom.loadMoreWrapper.show()
      }
    },
    countAll() {
      $dom.api.refreshAll()
      return $dom.all.length
    },
    countHidden() {
      $dom.api.refreshHidden()
      return $dom.hidden.length
    },
    countVisible() {
      $dom.api.refreshAll()
      $dom.api.refreshHidden()
      return $dom.all.length - $dom.hidden.length
    }
  }
})()
