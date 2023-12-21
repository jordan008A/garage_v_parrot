// Maximum character limit 400 for the textarea
const area400 = document.getElementById('area400');
const lengthValue400 = document.getElementById('lengthValue400');
      
area400.addEventListener('input', function() {
  const textLengthDetails = this.value.length;
  lengthValue400.textContent = textLengthDetails + ' / 400 caractères';
        
  if (textLengthDetails > 400) {
    this.value = this.value.substring(0, 400);
    lengthValue400.textContent = '400 / 400 caractères';
  }
});
  