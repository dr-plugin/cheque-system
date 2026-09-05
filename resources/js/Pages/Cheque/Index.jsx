import DashboardLayout from "@/Layouts/Dashboard/Layout"
import Pagination from "@/BaseComponents/Pagination"
import { formatAmount } from '@/functions/helper.js';
import ModalMoveCheque from "./Components/ModalMoveCheque";
import { LiaTrashAlt } from "react-icons/lia";
import { Link } from "@inertiajs/react";
import { AiOutlineEdit } from "react-icons/ai";
import FormField from "@/BaseComponents/FormField";
import { router, usePage } from "@inertiajs/react";
import { useState, useEffect } from "react";
import ModalUpdateStatus from "./Components/ModalUpdateStatus";
import { toast } from "react-toastify";

function Index({ cheques, h1, clientTrans, currentClientId }) {

    const { flash } = usePage().props;
    const [hideExpire, setHideExpire] = useState(false);

    useEffect(() => {
        if (flash.status)
            toast.success(flash.msg);
        else
            toast.error(flash.msg)
    }, [flash]);

    useEffect(() => {
        var urlParams = new URL(window.location.href).searchParams;
        var d = urlParams.get('date');
        
        if (d == 'hide-expire')
            setHideExpire(true);
    }, []);

    function addQuery(key, value) {
        const currentPath = window.location.href;
        router.get(
            currentPath,
            { [key]: value },
            { preserveState: true }
        );
    }

    return (
        <>
            <section>
                <FormField
                    name="hideUnDateCheque"
                    type="checkbox"
                    label="فقط چکهای مانده"
                    customClass="without-bg"
                    value={hideExpire}
                    onChange={(e) => {
                        const isChecked = e.target.checked;
                        addQuery('date', isChecked ? 'hide-expire' : '');
                        setHideExpire(isChecked);
                    }}
                />

            </section>

            <section className="table-container">

                <table className="responsive-table">
                    <thead>
                        <tr>
                            <th>شماره صیادی</th>
                            <th>نزد</th>
                            <th>صادر کننده</th>
                            <th>بانک</th>
                            <th>کاغذی/دیجیتال</th>
                            <th>تاریخ چک</th>
                            <th>مبلغ (ریال)</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        {cheques.data.map((item) => (

                            <tr key={item.id}>
                                <td>{item.sayadi_number}</td>
                                <td>{item.owner.name}</td>
                                <td>{item.exporter}</td>
                                <td>{item.bank_label}</td>
                                <td>{item.type_label}</td>
                                <td>{item.date_fa}</td>
                                <td>{formatAmount(item.price)}</td>
                                <td className={item.status}>{item.status_label}</td>

                                <td className="flex gap-2 justify-center">

                                    <ModalMoveCheque
                                        chequeId={item.id}
                                        price={item.price}
                                        due_date={item.due_date}
                                        date_fa={item.date_fa}
                                        payerId={item.owner.id}
                                        payerName={item.owner.name}
                                    />

                                    <Link
                                        href={`/cheque/${item.id}/edit`}
                                        className="ml-2"
                                    >
                                        <AiOutlineEdit size={24} />
                                    </Link>

                                    <ModalUpdateStatus
                                        cheque={item}
                                    />

                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>

                <Pagination links={cheques.links} />
            </section>

        </>
    )
}

Index.layout = page => <DashboardLayout children={page} h1={page.props.h1} />

export default Index;