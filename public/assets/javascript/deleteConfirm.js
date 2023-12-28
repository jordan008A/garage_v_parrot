document.addEventListener('DOMContentLoaded', function() {
  const deleteButtons = document.querySelectorAll('.btn-delete');

  deleteButtons.forEach(function(button) {
      button.addEventListener('click', function(event) {
          if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
              event.preventDefault();
          }
      });
  });
});