// Get the textarea element and the element to display the character count
const area175 = document.getElementById('area175');
const lengthValue175 = document.getElementById('lengthValue175');
      
// Add an event listener to the textarea for the 'input' event
area175.addEventListener('input', function() {
  // Calculate the length of the text entered in the textarea
  const textLengthDetails = this.value.length;
  // Display the current character count out of the maximum allowed
  lengthValue175.textContent = textLengthDetails + ' / 175 caractères';
});