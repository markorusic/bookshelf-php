export default class EventEmitter {
  constructor() {
    this.events = {}
  }
  on(event, handler) {
    if (this.events[event]) {
      this.events[event].push(handler)
    } else {
      this.events[event] = [handler]
    }
  }
  emit(event, payload) {
    const eventHandlers = this.events[event]
    if (eventHandlers) {
      eventHandlers.forEach(eventHandler => {
        eventHandler(payload)
      })
    }
  }
}
