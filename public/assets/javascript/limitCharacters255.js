// Retrieve the textarea and the character count display element
const area255 = document.getElementById('area255');
const lengthValue255 = document.getElementById('lengthValue255');
      
// Add an input event listener to the textarea
area255.addEventListener('input', function() {
  // Get the current length of the text in the textarea
  const textLengthDetails = this.value.length;
  // Display the current character count out of the maximum 255 characters
  lengthValue255.textContent = textLengthDetails + ' / 255 caractères';
});