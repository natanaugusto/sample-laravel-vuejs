import money from '../configs/money'

let FormatMoney = {
    toFloat(val) {
        val = val
            .replace(money.thousands, '')
            .replace(money.decimal, '.')
            .replace(money.prefix, '')
            .replace(money.suffix, '')
        return parseFloat(val).toFixed(money.precision)
    },
    toString(val) {
        val = (typeof val === 'string' ? val : val.toFixed(2))
            .replace('.', money.decimal)
        let decCount = money.precision + 1
        let len = val.length - decCount
        let thousandTime = Math.floor(len / 3)
        for(let i = 0; i < thousandTime; i++) {
            len = len - 3
            if(len > 0) {
                val = val.substr(0, len) + money.thousands + val.substr(len, val.length)
            }
        }
        return money.prefix + val
    }
}

export default FormatMoney
