import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import { useForm } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import Select from "react-dropdown-select";

let new_role = null;

export default function EditAdminRole({ auth, edituser, roles }) {
    const { patch, errors, processing, recentlySuccessful } = useForm({});

    const submit = (e) => {
        e.preventDefault();
        if(new_role != null) patch(route('profile.role.update', [edituser, new_role]));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">User #{edituser.id} {edituser.name} ({edituser.userole}) </h2>}
        >
        <div className="py-12">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg py-90">
                    <form onSubmit={submit} className="p-10 mt-6 space-y-6">
                        <div>
                            <InputLabel htmlFor="role" value="Role" />

                            <Select 
                                options={roles} 
                                labelField="role_name" 
                                valueField="id"
                                onChange={(values) => new_role = values[0]} />

                            <InputError className="mt-2" message={errors.role} />
                        </div>

                        <div className="flex items-center gap-4 div-on-bot">
                            <PrimaryButton disabled={processing}>Save</PrimaryButton>

                            <Transition
                                show={recentlySuccessful}
                                enter="transition ease-in-out"
                                enterFrom="opacity-0"
                                leave="transition ease-in-out"
                                leaveTo="opacity-0"
                            >
                                <p className="text-sm text-gray-600">Saved.</p>
                            </Transition>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        </AuthenticatedLayout>
    );
}
