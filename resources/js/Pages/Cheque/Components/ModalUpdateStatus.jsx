import { useState } from "react";
import { RxUpdate } from "react-icons/rx";
import ModalBb from "@/BaseComponents/ModalBb";
import Button from "@/BaseComponents/Button";
import FormField from "@/BaseComponents/FormField";
import { usePage, useForm } from "@inertiajs/react";
import Tooltip from "../../../BaseComponents/Tooltip";

function ModalUpdateStatus({ cheque }) {

    const [isOpen, setIsOpen] = useState(false);
    const { msg, chequeStatus } = usePage().props;
    const { data, setData, processing, put, errors, setError } = useForm({
        id: cheque.id,
        status: cheque.status
    });


    function addFormData(e) {
        const { id, type, value, checked } = e.target;

        setData((prevData) => {
            let val = type === 'checkbox' ? checked : value;
            return {
                ...prevData,
                [id]: val
            }
        });
    }

    function updateCheque(e) {

        e.preventDefault();

        if (data.status == cheque.status) {
            setError('status', 'وضعیت جدیدی انتخاب کنید');
            return;
        }

        put(`/cheque/${data.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                setIsOpen(false);
            }
        })
    }

    return (
        <>
            <Tooltip
                text="تغییر وضعیت"
                className="ml-2"
            >
                <RxUpdate
                    size={23}
                    onClick={() => setIsOpen(true)}
                />
            </Tooltip>


            <ModalBb
                isOpen={isOpen}
                head="تغییر وضعیت چک"
                onClose={() => setIsOpen(false)}
            >
                <form onSubmit={updateCheque}>

                    <FormField
                        name="status"
                        onChange={addFormData}
                        type="select"
                        label="نوع تراکنش"
                        value={data.status}
                        error={errors.status}
                        placeholder='انتخاب وضعیت جدید'
                        options={chequeStatus}
                    />

                    <Button isLoading={processing} />

                </form>

            </ModalBb>
        </>
    )
}

export default ModalUpdateStatus;