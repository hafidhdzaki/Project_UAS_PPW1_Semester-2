let currentQty = 1;

window.updateQty = function(change) {
    if(typeof maxStok === 'undefined' || maxStok === 0) return;
    
    let newQty = currentQty + change;
    if(newQty >= 1 && newQty <= maxStok) {
        currentQty = newQty;
        document.getElementById('qtyInput').value = currentQty;
        
        let totalPrice = basePrice * currentQty;
        document.getElementById('totalPrice').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');
    }
};
