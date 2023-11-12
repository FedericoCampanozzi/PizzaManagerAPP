import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Table from "@/Components/Table.jsx";

const chef_columns = [
    {name:'Size', value:'size'},
    {name:'Crust', value:'crust'},
    {name:'Client', value:'client'},
    {name:'Ordered', value:'ordered'},
    {name:'Chef', value:'chef'},
    {name:'Status', value:'pizzastatus'}
];

const deliveryman_columns = [
    {name:'Client', value:'client'},
    {name:'Ordered', value:'ordered'},
    {name:'Delivery Man', value:'deliveryman'},
    {name:'Status', value:'deliverystatus'}    
];

export default function GuerstDashboard({ auth, pizzas }) {
    const pageTitle = auth.user.fk_role == 2 ? "Chef Page" : "Delivery Man Page";
    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        {pageTitle}
                    </h2>
                }
            >
                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            {
                                auth.user.fk_role == 2 ?
                                (
                                    <Table  items={pizzas} 
                                            columns={chef_columns} 
                                            primary="Order Number"
                                            action="edit.status.chef"
                                            actionlabel="Edit Status"
                                            fixedHeader='true' />

                                ) : (
                                    <Table  items={pizzas}
                                            columns={deliveryman_columns}
                                            primary="Order Number"
                                            action="edit.status.deliveryman"
                                            actionlabel="Edit Status"
                                            fixedHeader='true'  />
                                )
                            }
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}