import { Link, Head } from "@inertiajs/react";

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    return (
        <>
            <Head title="Welcome" />
            <div className="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
                <div className="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    {auth.user ? (
                        <Link
                            href={route("dashboard")}
                            className="font-semibold text-gray-600 hover dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >
                            Dashboard
                        </Link>
                    ) : (
                        <>
                            <Link
                                href={route("login")}
                                className="font-semibold text-gray-600 hover dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                            >
                                Log in
                            </Link>

                            <Link
                                href={route("register")}
                                className="ml-4 font-semibold text-gray-600 hover dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                            >
                                Register
                            </Link>
                        </>
                    )}
                </div>
                <div className="max-w-7xl mx-auto p-6 lg:p-8 w-100">
                    <div className="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
                <div className="bg-welcome">
                        <div className="text-center text-sm w-100 title">
                            Pizza Manager APP
                        </div>

                </div>
                    </div>
                    <div className="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
                        <div className="text-center text-sm sm:text-left">
                            Federico Campanozzi
                        </div>

                        <div className="text-center text-sm sm:text-left">
                            <a href="https://github.com/FedericoCampanozzi/PizzaManagerAPP" target="_blank">
                                Github
                            </a>
                        </div>

                        <div className="ml-4 text-center text-sm sm:text-right sm:ml-0">
                            Laravel v{laravelVersion} (PHP v{phpVersion})
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
