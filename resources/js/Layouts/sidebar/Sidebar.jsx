import SidebarDisplay from "@/Components/SidebarDisplay";
import {
    FaTachometerAlt,
    FaUserInjured,
    FaUserMd,
    FaCalendarCheck,
    FaFileMedical,
    FaFileInvoiceDollar,
    FaPills,
    FaMicroscope,
    FaXRay,
    FaCog,
    FaHospital,
} from "react-icons/fa";

const Sidebar = () => {
    const sections = [
        {
            title: "Dashboard",
            links: [{
                text: "Home", href: "dashboard", icon: FaTachometerAlt,
                text: "Clinics", href: "clinic.index", icon: FaHospital
            }],
            icon: FaTachometerAlt,
        },
        {
            title: "Patients",
            links: [
                { text: "Patients", href: "dashboard", icon: FaUserInjured },
            ],
            icon: FaUserInjured,
        },
        {
            title: "Doctors",
            links: [{ text: "All Doctors", href: "doctor.index", icon: FaUserMd }],
            icon: FaUserMd,
        },
        {
            title: "Appointments",
            links: [
                {
                    text: "Manage Appointments",
                    href: "dashboard",
                    icon: FaCalendarCheck,
                },
            ],
            icon: FaCalendarCheck,
        },
        {
            title: "Medical Records",
            links: [
                {
                    text: "Records",
                    href: "dashboard",
                    icon: FaFileMedical,
                },
            ],
            icon: FaFileMedical,
        },
        {
            title: "Billing",
            links: [
                {
                    text: "Invoices",
                    href: "dashboard",
                    icon: FaFileInvoiceDollar,
                },
            ],
            icon: FaFileInvoiceDollar,
        },
        {
            title: "Pharmacy",
            links: [{ text: "Medicines", href: "dashboard", icon: FaPills }],
            icon: FaPills,
        },
        {
            title: "Laboratory",
            links: [{ text: "Tests", href: "dashboard", icon: FaMicroscope }],
            icon: FaMicroscope,
        },
        {
            title: "Radiology",
            links: [{ text: "Imaging", href: "dashboard", icon: FaXRay }],
            icon: FaXRay,
        },
        {
            title: "Settings",
            links: [
                { text: "General Settings", href: "dashboard", icon: FaCog },
            ],
            icon: FaCog,
        },
    ];

    return <SidebarDisplay sections={sections} />;
};

export default Sidebar;
