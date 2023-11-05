import All from "@/Pages/Pizzas/All";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function GuestDashboard({ auth }) {
    const pizzas = [];
    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Pizzas
                    </h2>
                }
            >
                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <All pizzas={pizzas} />
                        </div>
                    </div>
                </div>
            </AuthenticatedLayout>
        </>
    );
}