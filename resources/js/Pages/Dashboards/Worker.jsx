import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Table from "@/Components/Table.jsx";

export default function GuerstDashboard({ auth }) {
    const pizzas = [];
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
                            <Table  items={pizzas} 
                                    primary="User ID" 
                                    columns={['name','email','userrole']} 
                                    action="profile.partials.editrole"/>
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}