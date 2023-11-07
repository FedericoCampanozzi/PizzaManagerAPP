import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Table from "@/Components/Table.jsx";
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from "@fullcalendar/interaction";

import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend,
} from 'chart.js';
import { Bar } from 'react-chartjs-2';

ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend
);

const events = [
  { title: 'Meeting', start: new Date() }
]

export default function AdminDashboard({ auth, users }) {
   
 const options = {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Chart.js Bar Chart',
      },
    },
  };
  
  const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
  
   const data = {
    labels,
    datasets: [
      {
        label: 'Dataset 1',
        data: [1,2,3,45,6,7,8],
        backgroundColor: 'rgba(255, 99, 132, 0.5)',
      },
      {
        label: 'Dataset 2',
        data: [1,2,3,45,6,7,8],
        backgroundColor: 'rgba(53, 162, 235, 0.5)',
      },
    ],
  };
    
    const handleDateClick = (arg) => { // bind with an arrow function
        alert(arg.dateStr);
    }
    const eventClick = (arg) => { // bind with an arrow function
        console.log(arg);
        alert(arg);
    }
    return (
        <>
            <AuthenticatedLayout
                user={auth.user}
                header={
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        Administrator
                    </h2>
                }
            >
                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <Table  items={users} 
                                    primary="User ID" 
                                    columns={['name','email','userole']} 
                                    action="editrole"
                                    actionlabel='Edit Role'/>
                        </div>                        
                    </div>
                </div>

                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div className='p-5' style={{
                                    width:'50%',
                                    float:'left',
                                    height:'auto'}}>
                                <Bar options={options} data={data} />
                            </div>
                            <div className='p-5' style={{
                                    width:'50%',
                                    float:'right',
                                    height:'auto'}}>
                                <Bar options={options} data={data} />
                            </div>
                            <div className='p-5' style={{
                                    width:'50%',
                                    float:'left',
                                    height:'auto'}}>
                                <Bar options={options} data={data} />
                            </div>
                            <div className='p-5' style={{
                                    width:'50%',
                                    float:'right',
                                    height:'auto'}}>
                                <Bar options={options} data={data} />
                            </div>
                        </div>                        
                    </div>
                </div>
                
                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div className='p-10'>
                                <FullCalendar
                                    plugins={[dayGridPlugin, interactionPlugin]}
                                    initialView='dayGridMonth'
                                    weekends={true}
                                    events={events}
                                    eventClick={eventClick}
                                    dateClick={handleDateClick}
                                    eventContent={renderEventContent}/>
                            </div>
                        </div>                        
                    </div>
                </div>

            </AuthenticatedLayout>
        </>
    );
}

function renderEventContent(eventInfo) {
    return (
      <>
        <b>{eventInfo.timeText}</b>
        <i>{eventInfo.event.title}</i>
      </>
    )
}