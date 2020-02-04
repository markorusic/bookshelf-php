const dataTable = (function () {
  let props = {
    resource: null,
    searchBy: null,
    columns: []
  }

  let state = {
    sort: ''
  }

  const $dom = {
    root: null,
    search: null,
    table: null,
    pagination: null
  }

  const utils = {
    formatColumn(column) {
      return column.split('_').join(' ')
    },
    debounce(func, wait, immediate) {
      let timeout
      return function () {
        let context = this,
          args = arguments
        let later = function () {
          timeout = null
          if (!immediate) func.apply(context, args)
        }
        let callNow = immediate && !timeout
        clearTimeout(timeout)
        timeout = setTimeout(later, wait)
        if (callNow) func.apply(context, args)
      }
    }
  }

  const view = {
    renderContainer() {
      const html = `
        <div id="${props.resource}-data-table" class="container py-2">
          <div class="card-header">
            <div class="flex-sp-between">
              <h4 class="bold uc-first">${props.resource}</h4>
              <span>
                <a class="btn btn-success btn-sm" href="/admin/${
        props.resource
        }/create">
                  <i class="fa fa-plus" aria-hidden="true"></i> 
                  Create
                </a>
              </span>
            </div>
            ${(() => {
          if (props.searchBy) {
            return `
                  <div class="mt-1">
                    <input
                      type="text"
                      class="resource-table-search form-control"
                      placeholder="Search"
                      data-resource-search
                    >
                  </div>
                `
            return ''
          }
        })()}
          </div>
      
        <table class="table resource-table" data-resource-table>
        </table>
        <div data-resource-pagination></div>
      `
      $('body script')
        .first()
        .before(html)
      return $(`#${props.resource}-data-table`)
    },
    renderLoader() {
      $dom.table.html(`
      <div style="display: flex; height: 620px; justify-content: center; align-items: center; background-color: #428bca12;">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      `)
    },
    renderTable({ content = [], pagination = {} }) {
      const tableHtml = `
        <thead>
          <tr>
            <th>#</th>
            ${(() =>
          props.columns
            .map(
              column => `
              <th class="uc-first clickable" data-sort="${column}">
                <span>${utils.formatColumn(column)}<span>
                <span><i class="fa fa-sort" aria-hidden="true"></i></span>
              </th>
            `
            )
            .join(''))()}
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          ${(() =>
          content.map(
            (item, index) => `
            <tr data-id="${item.id}">
              <td>${pagination.page * pagination.size + index + 1}</td>
              ${(() =>
                props.columns
                  .map(column => {
                    switch (column) {
                      case 'main_photo':
                        return `
                      <td data-name="main_photo">
                        <img src="${
                          item[column]
                          }" alt="Photo not found" class="table-img">
                      </td>`

                      default:
                        return `<td data-name="${column}">${item[column]}</td>`
                    }
                  })
                  .join(''))()}
              
                <td class="flex resource-actions">
                  <a class="btn btn-primary white-txt mr-2 btn-sm"
                    href="/admin/${props.resource}/edit?id=${item.id}" 
                  >
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                  </a>
                  <a class="btn btn-danger white-txt btn-sm"
                    data-delete="/admin/${props.resource}/delete?id=${item.id}"
                  >
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                  </a>
                </td>
            </tr>
          `
          ))()}
        </tbody>
      `
      const pages = [
        ...Array(Math.ceil(pagination.totalElements / pagination.size)).keys()
      ]

      const paginationHtml = `
        <ul class="pagination">
          <li class="page-item${
        pagination.page > 0 ? '' : ' disabled'
        }" data-page="${pagination.page - 1}">
            <a class="page-link" href="#">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          ${pages
          .map(
            page =>
              `<li class="page-item${
              pagination.page === page ? ' active' : ''
              }" data-page="${page}"><a class="page-link" href="#">${page +
              1}</a></li>`
          )
          .join('')}

            <li class="page-item${
        pagination.page < pages.length - 1 ? '' : ' disabled'
        }" data-page="${pagination.page + 1}">
              <a class="page-link" href="#">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
        </ul>`
      $dom.table.html(tableHtml)
      $dom.pagination.html(paginationHtml)
    },
    renderErrorTable() {
      $dom.pagination.html('')
      $dom.table.html(`
      <div class="alert alert-warning mt-3 text-center" role="alert">
        Error happend while loading ${props.resource}.
      </div>
      `)
    }
  }

  function cacheDom() {
    $dom.root = view.renderContainer()
    $dom.search = $dom.root.find('[data-resource-search]')
    $dom.table = $dom.root.find('[data-resource-table]')
    $dom.pagination = $dom.root.find('[data-resource-pagination]')
  }

  function bindSearchEvent() {
    $dom.search.on('keyup', utils.debounce(handleSearch, 300))
  }
  function bindTableEvents() {
    $dom.table.find('[data-sort]').on('click', handleSort)
    $dom.table.find('[data-delete]').on('click', handleRecordDelete)
    $dom.pagination.find('[data-page]').on('click', handlePageChange)
  }

  // Fetch logic
  function fetchContent({ page = 0, size = 10, ...rest } = {}) {
    const restString = Object.entries(rest)
      .filter(([, value]) => !!value)
      .map(item => item.join('='))
      .join('&')
    const url = `/admin/${props.resource}?page=${page}&size=${size}${
      restString ? '&' + restString : ''
      }`
    return fetch(url).then(res => res.json())
  }

  // Load data procedure
  function loadData(options) {
    view.renderLoader()
    return fetchContent(options)
      .then(data => {
        view.renderTable(data)
        bindTableEvents()
      })
      .catch(view.renderErrorTable)
  }

  // Event handlers
  function handleSearch(event) {
    loadData({
      sort: state.sort,
      [props.searchBy]: event.target.value
    })
  }
  function handleSort(event) {
    const { sort } = $(event.currentTarget).data()
    const [sortParam, sortOrder] = state.sort.split(',')
    const order =
      sortParam !== sort ? 'desc' : sortOrder === 'desc' ? 'asc' : 'desc'

    state.sort = `${sort},${order}`

    loadData({
      sort: state.sort,
      page: $dom.pagination.find('.active').data().page,
      [props.searchBy]: $dom.search.val()
    })
  }
  function handleRecordDelete(event) {
    const $el = $(event.currentTarget)
    const $resourceEl = $el.parent().parent()
    const endpoint = $el.data().delete
    if (!endpoint || !confirm('Are you sure?')) {
      return null
    }
    fetch(endpoint, {
      method: 'DELETE'
    })
      .then(() => {
        $resourceEl.fadeOut()
      })
      .catch(error => {
        alert('error')
        console.log(error)
      })
  }
  function handlePageChange(event) {
    event.preventDefault()
    const { page } = $(event.currentTarget).data()
    loadData({
      page,
      sort: state.sort,
      [props.searchBy]: $dom.search.val()
    })
  }

  return {
    init(configProps) {
      props = { ...props, ...configProps }
      cacheDom()
      loadData().then(bindSearchEvent)
    }
  }
})()
