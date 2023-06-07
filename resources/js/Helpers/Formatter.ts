function currencyFormat(value: string | number): string {
    const parsed = typeof value === "string" ? Number.parseFloat(value) : value;

    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(parsed);
}

function discountFormat(value: string | number): string {
    const parsed = typeof value === "string" ? Number.parseFloat(value) : value;
    return `${parsed * 100} %`;
}

export { currencyFormat, discountFormat };
