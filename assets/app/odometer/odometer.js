/*function animateCounter (id, start, end, duration) {
  let obj = document.getElementById(id)
  let current = start
  let range = end - start
  let increment = end > start ? 1 : -1
  let step = Math.abs(Math.floor(duration / range))
  let timer = setInterval(function () {
    current += increment
    obj.textContent = current
    if (current == end) {
      clearInterval(timer)
    }
  }, step)
}

// Usage
animateCounter('counter', 100, 1000, 2000) // id of element, start number, end number, duration in milliseconds*/
