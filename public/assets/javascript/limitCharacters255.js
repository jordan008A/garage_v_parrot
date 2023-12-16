// Maximum character limit 255 for the textarea
const area255 = document.getElementById('area255');
const lengthValue255 = document.getElementById('lengthValue255');
      
area255.addEventListener('input', function() {
  const textLengthDetails = this.value.length;
  lengthValue255.textContent = textLengthDetails + ' / 255 caractères';
        
  if (textLengthDetails > 255) {
    this.value = this.value.substring(0, 255);
    lengthValue255.textContent = '255 / 255 caractères';
  }
});
  