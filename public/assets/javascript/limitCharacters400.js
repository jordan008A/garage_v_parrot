// Retrieve the textarea and the character count display element for a 400 character limit
const area400 = document.getElementById('area400');
const lengthValue400 = document.getElementById('lengthValue400');
      
// Add an input event listener to the textarea
area400.addEventListener('input', function() {
  // Calculate the current length of the text in the textarea
  const textLengthDetails = this.value.length;
  // Update the displayed character count out of the maximum 400 characters
  lengthValue400.textContent = textLengthDetails + ' / 400 caractères';
        
  // If the text exceeds 400 characters, truncate it to 400 characters
  if (textLengthDetails > 400) {
    this.value = this.value.substring(0, 400);
    // Display the maximum character count reached
    lengthValue400.textContent = '400 / 400 caractères';
  }
});