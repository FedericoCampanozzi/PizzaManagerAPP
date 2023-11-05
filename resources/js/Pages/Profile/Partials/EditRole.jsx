import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function EditAdminRole({ auth, edituser }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">User #{edituser.id} {edituser.name}</h2>}
        >

        </AuthenticatedLayout>
    );
}
