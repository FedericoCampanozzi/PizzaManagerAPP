import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Table from "@/Components/Table.jsx";

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
                                            columns={[
                                                'client',
                                                'ordered',
                                                'size',
                                                'toppings',
                                                'status'
                                            ]} 
                                            primary="Order Number"
                                            action="editchef"
                                            actionlabel="Edit Status" />

                                ) : (
                                    <Table  items={pizzas}
                                            columns={[
                                                'client',
                                                'ordered',
                                                'status',
                                                'delivery'
                                            ]}
                                            primary="Order Number"
                                            action="editdeliveryman"
                                            actionlabel="Edit Status" />
                                )
                            }
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}