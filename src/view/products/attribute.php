<script>
    let select_size = [
        {
            id: '60',
            text: '60 cm (3kg-6kg)'
        },
        {
            id: '73',
            text: '73 cm (6kg-8kg)'
        },
        {
            id: '80',
            text: '80 cm (8kg-10kg)'
        },
        {
            id: '90',
            text: '90 cm (11kg-13kg)'
        },
        {
            id: '100',
            text: '100 cm (14kg-16kg)'
        },
        {
            id: '110',
            text: '110 cm (17kg-18kg)'
        },
        {
            id: '120',
            text: '120 cm (19kg-20kg)'
        },
        {
            id: '130',
            text: '130 cm (21kg-23kg)'
        },
        {
            id: '140',
            text: '140 cm (24kg-27kg)'
        },
        {
            id: '150',
            text: '150 cm (28kg-32kg)'
        },
        {
            id: '160',
            text: '160 cm (33kg-40kg)'
        },
        {
            id: '3m',
            text: '3m'
        },
        {
            id: '6m',
            text: '6m'
        },
        {
            id: '9m',
            text: '9m'
        },
        {
            id: 'Free Size',
            text: 'Free Size'
        },
        {
            id: '1',
            text: '1'
        },
        {
            id: '2',
            text: '2'
        },
        {
            id: '3',
            text: '3'
        },
        {
            id: '4',
            text: '4'
        },
        {
            id: '5',
            text: '5'
        },
        {
            id: '6',
            text: '6'
        },
        {
            id: '7',
            text: '7'
        },
        {
            id: '8',
            text: '8'
        },
        {
            id: '9',
            text: '9'
        },
        {
            id: '10',
            text: '10'
        },
        {
            id: '11',
            text: '11'
        },
        {
            id: '12',
            text: '12'
        },
        {
            id: '13',
            text: '13'
        },
        {
            id: '14',
            text: '14'
        },
        {
            id: '15',
            text: '15'
        },
        {
            id: '16',
            text: '16'
        },
        {
            id: '17',
            text: '17'
        },
        {
            id: '18',
            text: '18'
        },
        {
            id: '19',
            text: '19'
        },
        {
            id: '20',
            text: '20'
        },
        {
            id: '1T',
            text: '1T'
        },
        {
            id: '2T',
            text: '2T'
        },
        {
            id: '3T',
            text: '3T'
        },
        {
            id: '4T',
            text: '4T'
        },
        {
            id: '5T',
            text: '5T'
        },
        {
            id: '6T',
            text: '6T'
        },
        {
            id: '7T',
            text: '7T'
        },
        {
            id: '8T',
            text: '8T'
        },
        {
            id: '9T',
            text: '9T'
        },
        {
            id: '10T',
            text: '10T'
        },
        {
            id: '11T',
            text: '11T'
        },
        {
            id: '12T',
            text: '12T'
        },
        {
            id: '13T',
            text: '13T'
        },
        {
            id: '14T',
            text: '14T'
        },
        {
            id: '15T',
            text: '15T'
        },
        {
            id: '16T',
            text: '16T'
        },
        {
            id: '17T',
            text: '17T'
        },
        {
            id: '18T',
            text: '18T'
        },
        {
            id: '19T',
            text: '19T'
        },
        {
            id: '20T',
            text: '20T'
        }
    ];
    let select_colors = [
        {
            id: 'Trắng',
            text: 'Trắng'
        },
        {
            id: 'Xanh',
            text: 'Xanh'
        },
        {
            id: 'Đỏ',
            text: 'Đỏ'
        },
        {
            id: 'Tím',
            text: 'Tím'
        },
        {
            id: 'Vàng',
            text: 'Vàng'
        },
        {
            id: 'Xám',
            text: 'Xám'
        },
        {
            id: 'Hồng',
            text: 'Hồng'
        },
        {
            id: 'Đen',
            text: 'Đen'
        },
        {
            id: 'Nâu',
            text: 'Nâu'
        },
        {
            id: 'Kem',
            text: 'Kem'
        },
        {
            id: 'Bạc',
            text: 'Bạc'
        },
        {
            id: 'Cam',
            text: 'Cam'
        },
        {
            id: 'Kẻ',
            text: 'Kẻ'
        }
    ];
    let select_qty = [
        {
            id: '0',
            text: '0'
        },
        {
            id: '1',
            text: '1'
        },
        {
            id: '2',
            text: '2'
        },
        {
            id: '3',
            text: '3'
        },
        {
            id: '4',
            text: '4'
        },
        {
            id: '5',
            text: '5'
        },
        {
            id: '6',
            text: '6'
        },
        {
            id: '7',
            text: '7'
        },
        {
            id: '8',
            text: '8'
        },
        {
            id: '9',
            text: '9'
        },
        {
            id: '10',
            text: '10'
        },
        {
            id: '11',
            text: '11'
        },
        {
            id: '12',
            text: '12'
        },
        {
            id: '13',
            text: '13'
        },
        {
            id: '14',
            text: '14'
        }
    ];
    let select_types = [
        {
            id: '-1',
            text: ''
        },
        {
            id: '0',
            text: 'Bé trai'
        },
        {
            id: '1',
            text: 'Bé gái'
        },
        {
            id: '2',
            text: 'Trai gái'
        },
        {
            id: '3',
            text: 'Sơ sinh'
        }
    ];
    let select_cats = [
        {
            id: '-1',
            text: ''
        },
        {
            id: '1',
            text: 'Bộ quần áo'
        },
        {
            id: '2',
            text: 'Áo'
        },
        {
            id: '3',
            text: 'Quần'
        },
        {
            id: '4',
            text: 'Váy'
        },
        {
            id: '5',
            text: 'Giày'
        },
        {
            id: '6',
            text: 'Dép'
        },
        {
            id: '7',
            text: 'Mũ'
        },
        {
            id: '8',
            text: 'Phụ kiện'
        }
    ];
    let select_origin = [
        {
            id: '-1',
            text: ''
        },
        {
            id: '1',
            text: 'Việt Nam'
        },
        {
            id: '2',
            text: 'Trung Quốc'
        }
    ];
    let select_material = [
        {
            id: '-1',
            text: ''
        },
        {
            id: '1',
            text: 'Cotton'
        },
        {
            id: '2',
            text: 'Kaki'
        },
        {
            id: '3',
            text: 'Jeans'
        },
        {
            id: '4',
            text: 'Thô'
        },
        {
            id: '5',
            text: 'Voan'
        },
        {
            id: '6',
            text: 'Lanh'
        },
        {
            id: '7',
            text: 'đũi'
        },
        {
            id: '8',
            text: 'Ren'
        },
        {
            id: '9',
            text: 'PE'
        },
        {
            id: '10',
            text: 'nylon'
        },
        {
            id: '11',
            text: 'Nỉ'
        },
        {
            id: '12',
            text: 'Len'
        }
    ];
</script>
