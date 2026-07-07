import React from "react";

function FormField({
    name,
    type = "text",
    label,
    value,
    onChange,
    error,
    required = false,
    placeholder = "",
    options = [], // Array of { value, label } for select inputs
}) {

    const isSelect = type === "select";

    var classes = 'form-group';
    classes += isSelect ? ' select' : '';

    return (
        <div className={classes} >
            {
                isSelect ? (
                    <select
                        name={name}
                        id={name}
                        value={value}
                        onChange={onChange}
                        required={required}
                    >
                        {placeholder && <option value="" disabled>{placeholder}</option>}
                        {
                            options.map((opt) => (
                                <option key={opt.value} value={opt.value}>
                                    {opt.label}
                                </option>
                            ))
                        }
                    </select >
                ) : (
                    <input
                        type={type}
                        name={name}
                        id={name}
                        value={value}
                        onChange={onChange}
                        required={required}
                        placeholder={placeholder}
                    />
                )
            }
            <label htmlFor={name}>{label}</label>
            {error && <div className="errors">{error}</div>}
        </div >
    );
}

export default FormField;