type Statistic = {
    total_sales: number;
    total_revenue: string;
    total_customer: number;
    total_ticket: number;
};

type Ticket = {
    code: string;
    customer_id: number;
    product_id: string;
    subject: string;
    issue: string;
    ticket_date: string;
};

type Sale = {
    id: number;
    invoice_number: string;
    customer_id: number;
    weight_total: string;
    shipping_cost: string;
    total_price: string;
    total_purchase_price: string;
    shipping_date: string;
    shipping_type: number;
    transaction_date: string;
};

export { Statistic, Ticket, Sale };
