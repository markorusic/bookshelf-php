const _userActivtityTrack = (function() {
  let isInitialized = false

  function updateActivity() {
    fetch('/api/update-user-activity', {
      method: 'POST'
    })
  }

  return {
    init() {
      if (isInitialized === false) {
        isInitialized = true
        updateActivity()
        $(function() {
          setInterval(updateActivity, 30 * 1000)
        })
      }
    }
  }
})()

_userActivtityTrack.init()
