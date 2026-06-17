document.addEventListener('DOMContentLoaded', function() {
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');
    
    if(priceRange) {
        priceRange.addEventListener('input', function() {
            let val = parseInt(this.value).toLocaleString('id-ID');
            priceValue.textContent = 'Rp ' + val;
        });
    }
});
