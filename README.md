"# mineral_water" 
# Login in Web
    * Only person with Admin role have rights to login.
# Login In Mobile App
    * Only Delivery Boy, Driver and Salesman can login through android application.

# Cash & G-Pay are Payment on Delivery
# At the time of new order placement 
    * Payment Modes
        * Credit,
        * Cash
        * G-Pay
        * Bank Transfer,
        * Cheque        
    * Check credit limit for client if payment mode is in Credit, Bank Transfer & Cheque. not for Cash & G-Pay

# At the time of order delivery
    * Payment Modes
        * Credit,
        * Cash
        * G-Pay
        * Bank Transfer,
        * Cheque        
    * Check credit limit for client if payment mode is Credit.
    * If payment mode is Cash/G-Pay , Payment posting will be done automatically.

# Payments List
    * Only most recent payment of a client can be deleted.

# Order List
    * In order list Order Edit button will be visible only if order is not waiting approval
    * Order Edit
        * Only orders which are pending (exluding approval required) can be edited & deleted. (For others show error, rare case)
        * User can remove and add new items in order.
        * Product quantity should be integer & price should be either integer or decimal value.
        * User shoul'd not be able to remove all order items, at least 1 item must be present.
        * After submit check for applicable scheme and if found let the user choose scheme from applicable schemes.
        * Update Client specific product price if user changes price of a product.



TODO: Check scheme logic while approve order
TODO: mobile msg send is disabled in FCM library. (temporary)