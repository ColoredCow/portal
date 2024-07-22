$('#contractorFee').on("keyup", "", (e) => {
    onUpdateMonthlyFee(e.target.value)
});

function onUpdateMonthlyFee(value) {
    var tds = document.getElementById('contractorTds')
    tds.value = Math.floor(value * 0.02)
}