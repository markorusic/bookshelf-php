const dashboard = (function() {
  const REFRESH_INTERVAL = 15 * 1000
  let ctx = null
  let chart = null
  let activeUsersContainer = null

  function fetchPageViews() {
    return fetch('/admin/page-views')
      .then(res => res.json())
      .then(data => {
        let totalviews = 0

        return Object.entries(data)
          .map(([uri, views]) => {
            totalviews += views.length
            return [uri, views.length]
          })
          .map(([uri, views]) => [uri, Math.round((views / totalviews) * 100)])
          .sort((a, b) => b[1] - a[1])
      })
  }

  function renderPageViews(data) {
    if (!ctx) {
      return
    }

    const labels = []
    const viewsData = []

    data.forEach(([page, views]) => {
      if (labels.length < 20) {
        labels.push(page)
        viewsData.push(views)
      }
    })

    const datasets = [
      {
        backgroundColor: randomColor({
          count: viewsData.length,
          luminosity: 'light',
          hue: 'green'
        }),
        data: viewsData
      }
    ]

    if (!chart) {
      chart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels,
          datasets
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: { display: false }
        }
      })
    } else {
      chart.data.labels = labels
      chart.data.datasets = datasets
      chart.update()
    }
  }

  function fetchActiveUsers() {
    return fetch('/admin/active-users').then(res => res.json())
  }

  function renderActiveUsers(users) {
    if (!activeUsersContainer) {
      return
    }
    activeUsersContainer.innerHTML = `
    <h6>Active users (${users.length}) :</h6>
      <ul class="list-group">
        ${users
          .map(
            user => `
          <li class="list-group-item d-flex justify-content-between align-items-center">
            ${user.name}
            <span class="badge badge-${
              user.role === 'admin' ? 'primary' : 'success'
            } badge-pill">${user.role}</span>
          </li>
        `
          )
          .join('')}
    </ul>
    `
  }

  return {
    initPageViews({ container, refreshInterval = REFRESH_INTERVAL }) {
      ctx = document.querySelector(container).getContext('2d')
      fetchPageViews().then(renderPageViews)
      if (refreshInterval) {
        setInterval(() => {
          fetchPageViews().then(renderPageViews)
        }, refreshInterval)
      }
    },
    initActiveUsers({ container, refreshInterval = REFRESH_INTERVAL }) {
      activeUsersContainer = document.querySelector(container)
      fetchActiveUsers().then(renderActiveUsers)
      if (refreshInterval) {
        setInterval(() => {
          fetchActiveUsers().then(renderActiveUsers)
        }, refreshInterval)
      }
    }
  }
})()
