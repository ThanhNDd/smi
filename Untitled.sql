select 
	sum(tmp.total_checkout) as total_checkout, 
	sum(tmp.profit - tmp.discount) as total_profit,
	count(tmp.type) as count_type, 
	tmp.type,
	tmp.payment_type
from (
	SELECT A.id, A.discount,
		
        sum(D.profit * B.quantity - B.reduce) as profi-- 
		A.type,  A.payment_type,
        case A.payment_exchange_type
        when 2 then 0 - A.total_amount + A.total_reduce
        else A.total_amount - A.total_reduce
        end as 'total_checkout'
	FROM smi_orders A
		LEFT JOIN smi_order_detail B ON A.id = B.order_id
		LEFT JOIN smi_customers C ON A.customer_id = C.id
		LEFT JOIN smi_variations E ON B.variant_id = E.id
		LEFT JOIN smi_products D ON E.product_id = D.id
        LEFT JOIN (select 
        case B.type
        when 1 then 0 - sum(D.profit * B.quantity - B.reduce) 
        else sum(D.profit * B.quantity - B.reduce) 
        end as profit
        from smi_orders A
		LEFT JOIN smi_order_detail B ON A.id = B.order_id
        LEFT JOIN smi_variations E ON B.variant_id = E.id
		LEFT JOIN smi_products D ON E.product_id = D.id 
        where DATE(order_date) between DATE('2020-02-08') and DATE('2020-02-08')
		and A.deleted = 0
        group by B.type)
	where DATE(order_date) between DATE('2020-02-08') and DATE('2020-02-08')
	and A.deleted = 0
	group by A.id, A.discount,A.type,  A.payment_type
	) tmp
group by
	tmp.type,
	tmp.payment_type
order by 
	tmp.type;
    
    
    SELECT *
	FROM smi_orders A
		LEFT JOIN smi_order_detail B ON A.id = B.order_id
		LEFT JOIN smi_customers C ON A.customer_id = C.id
		LEFT JOIN smi_variations E ON B.variant_id = E.id
		LEFT JOIN smi_products D ON E.product_id = D.id
        where DATE(order_date) between DATE('2020-02-08') and DATE('2020-02-08')
	and A.deleted = 0;
    
    Error Code: 1064. You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'smi_order_detail B LEFT JOIN smi_variations E ON B.variant_id = E.id   LEFT JOIN' at line 6
