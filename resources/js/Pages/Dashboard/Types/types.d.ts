type Statistic = {
    total_sales: number;
    total_revenue: string;
    total_customer: number;
    total_ticket: number;
};

type SalesChart = {
    label: string;
    series: SalesChartItem[];
};

type SalesChartItem = {
    year: number;
    month_number: number;
    month: string;
    total_purchase_price: string;
};

type SeriesItem = {
    x: string;
    y: string;
};

type Series = {
    name: string;
    data: SeriesItem[];
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

export {
    Statistic,
    SalesChart,
    SalesChartItem,
    Series,
    SeriesItem,
    Ticket,
    Sale,
};
