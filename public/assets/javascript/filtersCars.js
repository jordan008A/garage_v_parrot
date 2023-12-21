document.querySelectorAll('.filter').forEach(filter => {
  filter.addEventListener('input', function() {
    const yearMin = document.getElementById('yearMin').value;
    const yearMax = document.getElementById('yearMax').value;
    const kmMin = document.getElementById('kmMin').value;
    const kmMax = document.getElementById('kmMax').value;
    const priceMin = document.getElementById('priceMin').value;
    const priceMax = document.getElementById('priceMax').value;

    fetch(`/filter/occasions?yearMin=${yearMin}&yearMax=${yearMax}&kmMin=${kmMin}&kmMax=${kmMax}&priceMin=${priceMin}&priceMax=${priceMax}`)
      .then(response => response.json())
      .then(data => {
        updateCarsDisplay(data.cars);
    });
  });
});

function updateCarsDisplay(cars) {
  let container = document.getElementById('carListContainer');
  container.innerHTML = '';

  cars.forEach(car => {
      container.innerHTML += `
          <div class="col-md-5 my-3 p-0 card">
              <img src="${car.primaryPictureUrl}" class="card-img-top w-100 img-fluid m-0 p-0 dynamic-height" alt="Car Image">
              <div class="card-body">
                  <p class="card-title text-center fs-4">${car.title}</p>
                  <p class="card-text text-center">Marque: ${car.brand}</p>
                  <p class="card-price text-center fs-4">${car.price}€</p>
                  <p class="card-text text-center">Année: ${car.year}</p>
                  <p class="card-text text-center">${car.mileage}km</p>
                  <a href="/occasions/${car.id}" class="btn button-p d-block">Plus de détails</a>
              </div>
          </div>`;
  });
  updateImageHeight();
}
