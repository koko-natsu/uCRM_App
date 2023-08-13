export const genderColor = gender => {
    if(gender === 1) {
        return 'border-blue-500 rounded-tl-xl'
    } else if(gender === 2) {
        return 'border-red-500'
    } else {
        return 'border-green-500'
    }
}