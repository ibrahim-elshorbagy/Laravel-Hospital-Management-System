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
    FaHandHoldingMedical,
} from "react-icons/fa";

import { MdMedicalServices } from "react-icons/md";

const Sidebar = ({ user }) => {
    const sections = [
        //receptionist
        {
            title: "Dashboard",
            links: [
                { text: "Home", href: "dashboard", icon: FaTachometerAlt },
                { text: "Clinics", href: "clinic.index", icon: FaHospital },
            ],
            icon: FaTachometerAlt,
            roles: ["admin", "manager"],
        },
        {
            title: "Accounting",
            links: [
                {
                    text: "Invoices",
                    href: "invoice.index",
                    icon: FaFileInvoiceDollar,
                },
            ],
            icon: FaFileInvoiceDollar,
            roles: ["admin", "accountant"],
        },

        //Admin

        {
            title: "Doctors",
            links: [
                { text: "All Doctors", href: "doctor.index", icon: FaUserMd },
            ],
            icon: FaUserMd,
            roles: ["admin"],
        },
        {
            title: "Services",
            links: [
                {
                    text: "Services",
                    href: "service.index",
                    icon: FaHandHoldingMedical,
                },
                {
                    text: "Packages",
                    href: "package.index",
                    icon: MdMedicalServices,
                },
            ],
            icon: FaHandHoldingMedical,
            roles: ["admin"],
        },
        {
            title: "Patients",
            links: [
                {
                    text: "Patients",
                    href: "patient.index",
                    icon: FaUserInjured,
                },
            ],
            icon: FaUserInjured,
            roles: ["admin"],
        },

        //patient
        {
            title: "My Invoices",
            links: [
                {
                    text: "Patients",
                    href: "my-invoice",
                    icon: FaFileInvoiceDollar,
                },
            ],
            icon: FaFileInvoiceDollar,
            roles: ["patient"],
        },
        //doctor

        {
            title: "Appointments",
            links: [
                {
                    text: "Manage Appointments",
                    href: "dashboard.index",
                    icon: FaCalendarCheck,
                },
            ],
            icon: FaCalendarCheck,
            roles: ["admin", "doctor", "receptionist"],
        },
        {
            title: "Medical Records",
            links: [
                {
                    text: "Records",
                    href: "dashboard.index",
                    icon: FaFileMedical,
                },
            ],
            icon: FaFileMedical,
            roles: ["admin", "doctor", "nurse"],
        },
        {
            title: "Pharmacy",
            links: [
                { text: "Medicines", href: "dashboard.index", icon: FaPills },
            ],
            icon: FaPills,
            roles: ["admin", "pharmacist"],
        },
        {
            title: "Laboratory",
            links: [
                { text: "Tests", href: "dashboard.index", icon: FaMicroscope },
            ],
            icon: FaMicroscope,
            roles: ["admin", "lab_technician"],
        },
        {
            title: "Radiology",
            links: [{ text: "Imaging", href: "dashboard.index", icon: FaXRay }],
            icon: FaXRay,
            roles: ["admin", "radiologist"],
        },
        {
            title: "Settings",
            links: [
                {
                    text: "General Settings",
                    href: "dashboard.index",
                    icon: FaCog,
                },
            ],
            icon: FaCog,
            roles: ["admin"],
        },
    ];

    // Filter sections based on user roles
    const filteredSections = sections.filter((section) =>
        section.roles.some((role) => user.roles.includes(role))
    );

    return <SidebarDisplay sections={filteredSections} />;
};

export default Sidebar;
