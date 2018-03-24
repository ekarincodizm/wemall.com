/**
 * price_format func is used to format currency.
 */

function price_format(price, currency, decimals, discount)
{
    if(price == null || price == undefined){
        return "";
    }
    if (typeof price != 'number')
    {
        return "";
    }
    
    currency = (currency == undefined || currency == null)? "PHP" : currency;
    decimals = (decimals == undefined || decimals == null)? 2 : decimals;
    discount = (discount == undefined || discount == null)? false : discount;
    
    
    switch(currency){
        case "USD":
            if(discount == true && price != 0){
                return '$ -' + price.formatMoney(decimals);
            } else {
                return '$ ' + price.formatMoney(decimals);
            }
            break;
        default:
            if(discount == true && price != 0){
                return '₱ -' + price.formatMoney(decimals);
            } else {
                return '₱ ' + price.formatMoney(decimals);
            }
            break;
    }
    
}
