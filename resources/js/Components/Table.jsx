import NavLink from "./NavLink";

export default function Table({ items, columns, primary, action, actionlabel="View Details", noResultLabel="Zero Result" }) {
    return (
        <div className="relative overflow-x-auto border shadow-md sm:rounded-lg">
            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" className="px-6 py-3">Nr.</th>
                    <th scope="col" className="px-6 py-3">{primary}</th>
                    {columns.map((column) =>
                        <th key={column} scope="col" className="px-6 py-3">{column}</th>
                    )}
                    <th scope="col" className="px-6 py-3"></th>
                </tr>
                </thead>
                <tbody>
                {
                    items.length == 0 ? (
                        <tr><td className="px-6 py-4" colSpan={columns.length+3}>{noResultLabel}</td></tr>
                    ):(
                        <></>
                    )
                }
                {items.map((item, index) =>
                    <tr key={item.id} className="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {index+1}
                        </th>
                        <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            #{item.id}
                        </th>
                        {columns.map((column) =>
                            <td key={column} className="px-6 py-4">
                                {item[column]}
                            </td>
                        )}
                        {
                            action != null?(
                                <td className="px-6 py-4">
                                    <NavLink href={route(action, item.id)} active={route().current(action)}
                                        className="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        {actionlabel}
                                    </NavLink>
                                </td>
                            ) : (
                                <></>
                            )
                        }
                    </tr>
                )}
                </tbody>
            </table>
        </div>
    );
}
