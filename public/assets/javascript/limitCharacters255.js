// Retrieve the textarea and the character count display element
const area255 = document.getElementById('area255');
const lengthValue255 = document.getElementById('lengthValue255');
      
// Add an input event listener to the textarea
area255.addEventListener('input', function() {
  // Get the current length of the text in the textarea
  const textLengthDetails = this.value.length;
  // Display the current character count out of the maximum 255 characters
  lengthValue255.textContent = textLengthDetails + ' / 255 caractères';
        
  // If the text length exceeds 255 characters, truncate it to 255 characters
  if (textLengthDetails > 255) {
    this.value = this.value.substring(0, 255);
    // Update the character count display to show the maximum limit
    lengthValue255.textContent = '255 / 255 caractères';
  }
});