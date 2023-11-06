import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import { useForm } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import SelectInput from "@/Components/SelectInput.jsx";

export default function EditAdminRole({ auth, edituser, options }) {
    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
        role: edituser.userole
    });

    const submit = (e) => {
        e.preventDefault();
        console.log(data.role);
        patch(route('user_role.update', edituser.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">User #{edituser.id} {edituser.name}</h2>}
        >
        <div className="py-12">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form onSubmit={submit} className="p-10 mt-6 space-y-6">
                        <div>
                            <InputLabel htmlFor="role" value="Role" />

                            <SelectInput
                                id="role"
                                className="mt-1 block w-full"
                                options={options}
                                value={data.role}
                                onChange={(e) => setData('role', e.target.value)}
                            />

                            <InputError className="mt-2" message={errors.role} />
                        </div>

                        <div className="flex items-center gap-4">
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
