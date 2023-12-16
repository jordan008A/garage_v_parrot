// Maximum character limit 175 for the textarea
const area175 = document.getElementById('area175');
const lengthValue175 = document.getElementById('lengthValue175');
      
area175.addEventListener('input', function() {
  const textLengthDetails = this.value.length;
  lengthValue175.textContent = textLengthDetails + ' / 175 caractères';
        
  if (textLengthDetails > 175) {
    this.value = this.value.substring(0, 175);
    lengthValue175.textContent = '175 / 175 caractères';
  }
});