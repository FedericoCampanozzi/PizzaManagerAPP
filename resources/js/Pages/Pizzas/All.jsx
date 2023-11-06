import Table from "@/Components/Table.jsx";

const columns = [
    'client',
    'size',
    'toppings',
    'status',
    'chef',
    'deliveryman',
    'delivery'
];

export default function All({ pizzas }) {
    return (
        <div className="py-12">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Table  items={pizzas} 
                            columns={columns} 
                            primary="Order Number" 
                            action="pizzas.showorderdetail"
                            noResultLabel="You didn't order any pizzas" />
                </div>
            </div>
        </div>
    );
}