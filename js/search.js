const search = document.getElementById('search-input');


search.addEventListener('input', () => {
  const value = search.value.toLowerCase();
  const vents = document.querySelectorAll('.vent-card');

  vents.forEach(vent => {
    const text = vent.textContent.toLowerCase();
    vent.style.display = text.includes(value) ? '' : 'none';
  })
})
