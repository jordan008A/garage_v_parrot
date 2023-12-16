// Script pour basculer l'affichage des filtres
const toggleFiltersBtn = document.getElementById('toggleFiltersBtn');
const filters = document.getElementById('filters');

toggleFiltersBtn.addEventListener('click', function() {
  if (filters.style.display === 'none' || filters.style.display === '') {
    filters.style.display = 'flex';
  } else {
    filters.style.display = 'none';
  }
});