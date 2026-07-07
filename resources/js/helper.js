export function formatAmount(amount) {
    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


export function showPretty(str) {
    try {
        const obj = JSON.parse(str);
        const pretty = JSON.stringify(obj, null, 2);
        return pretty;
    } catch (e) {
        return `Invalid JSON`;
    }
}
