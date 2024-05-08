DROP DATABASE TasMana
USE TasMana
GO

CREATE FUNCTION taoMaGiaoViec(@maNguoiGiao VARCHAR(10))
RETURNS VARCHAR(20) AS
BEGIN
	DECLARE @maGiaoViecMoi VARCHAR(20)
	DECLARE @maGiaoViec VARCHAR(20)
	-- @maGiaoViec ngay lúc này là mã lớn nhất của người giao đã cho
	SELECT TOP 1
		@maGiaoViec = maGiaoViec
	FROM GiaoViec
	WHERE maGiaoViec LIKE @maNguoiGiao + '.%'
	ORDER BY maGiaoViec DESC
	IF @maGiaoViec IS NULL
		SET @maGiaoViecMoi = @maNguoiGiao + '.001'
	ELSE
		SET @maGiaoViecMoi = @maNguoiGiao + '.' + RIGHT('000' + CAST(CAST(SUBSTRING(@maGiaoViec, CHARINDEX('.', @maGiaoViec) + 1, LEN(@maGiaoViec) - CHARINDEX('.', @maGiaoViec)) AS INT) + 1 AS VARCHAR(3)), 3)
	RETURN @maGiaoViecMoi
END

-- Procedure tạo việc
ALTER PROCEDURE taoViec(
	@moTaCongViec NVARCHAR(500),
	@ngayGiao DATE,
	@hanHoanThanh DATE,
	@tinhTrangCongViec NVARCHAR(100),
	@dinhKemFile VARCHAR(500),
	@maGiaoViec VARCHAR(10),
	@maThanhVien VARCHAR(10),
	@cheDo BIT,
	@tenCongViec NVARCHAR(200),
	@laCEO BIT,
	@maNguoiGiao VARCHAR(10),
	@maCanHo VARCHAR(10)
)
AS
BEGIN
	IF @laCEO = 1
  BEGIN
		IF NOT EXISTS (SELECT maThanhVien
		FROM CEO
		WHERE maThanhVien = @maNguoiGiao)
	BEGIN
			PRINT N'Quyền này thuộc về CEO';
			RETURN -1;
		END;
	END
  ELSE 
  BEGIN
		IF NOT EXISTS (SELECT maThanhVien
		FROM QuanLi
		WHERE maThanhVien = @maNguoiGiao)
	BEGIN
			PRINT N'Quyền này thuộc về quản lý';
			RETURN -1;
		END;
	END

	INSERT INTO GiaoViec
	VALUES
		(
			@moTaCongViec,
			@ngayGiao,
			@hanHoanThanh,
			@tinhTrangCongViec,
			@dinhKemFile,
			@maGiaoViec,
			@cheDo,
			@tenCongViec
    );
	INSERT INTO NhanViec
	VALUES
		(
			@maGiaoViec,
			@maThanhVien
	)
	INSERT INTO KhuVucLamViec VALUES (@maGiaoViec, @maCanHo)
	PRINT N'Tạo việc thành công';
	RETURN 0
END;
GO

-- Procedure ủy quyền
ALTER PROCEDURE uyQuyen
	@maThanhVien VARCHAR(20),
	@maCEO VARCHAR(20)
AS
BEGIN
	IF NOT EXISTS (SELECT *
	FROM CEO
	WHERE maThanhVien = @maCEO)
	BEGIN
		PRINT N'Quyền này thuộc về CEO'
		RETURN -1
	END
	UPDATE NhanSu SET laQuanLi = 1 WHERE maThanhVien = @maThanhVien
	INSERT INTO QuanLi
	VALUES
		(@maThanhVien)
END
GO

SELECT *
FROM QUANLI
SELECT NhanVien.maThanhVien, NhanSu.hoVaTen
FROM NhanVien INNER JOIN NhanSu on NhanVien.maThanhVien = NhanSu.maThanhVien
WHERE maPB = 'VS' and laQuanLi = 1

-- Procedure truất quyền
CREATE PROCEDURE truatQuyen
	@maThanhVien VARCHAR(20),
	@maCEO VARCHAR(20)
AS
BEGIN
	IF NOT EXISTS (SELECT *
	FROM CEO
	WHERE maThanhVien = @maCEO)
	BEGIN
		PRINT N'Quyền này thuộc về CEO'
		RETURN -1
	END
	UPDATE NhanSu SET laQuanLi = 0 WHERE maThanhVien = @maThanhVien
	DELETE FROM QuanLi WHERE maThanhVien = @maThanhVien
END
GO

ALTER TABLE NhanSu ADD gioiTinh NVARCHAR(10)
ALTER TABLE NhanSu ADD diaChi NVARCHAR(100)
ALTER TABLE NhanSu ADD ngayBatDau DATE
-- Thêm mấy trường này vô hỗ trợ code truy vấn này kia
ALTER TABLE NhanVien ADD laQuanLi BIT
ALTER TABLE QuanLi ADD hoVaTen VARCHAR(100)
ALTER TABLE CEO ADD hoVaTen VARCHAR(100)
EXEC taoNhanSu  'KT-503', '12345678', N'LE PHAN THE VI', '0124356789', '20041016', '9282737333', 'thevi16102004@gmail.com', 
0, N'Avatar siêu vjp pro', 1, 'KT', N'Quản lý', 1, N'283 Lê Văn Lương', '20240220'
-- CHỈNH SỬA: KHI TẠO QUẢN LÝ THÌ NHÂN VIÊN INSERT VÔ
-- Procedure insert Nhân sự cho công ty
ALTER PROCEDURE taoNhanSu
  @maThanhVien varchar(10),
  @matKhau varchar(12),
  @hoVaTen nvarchar(100),
  @SDT varchar(15),
  @namSinh date,
  @CCCD varchar(20),
  @email varchar(200),
  @nghiViec bit,
  @anhDaiDien varchar(500),
  @laQuanLi bit,
  @maPB varchar(10),
  @loaiNhanSu nvarchar(100),
  @gioiTinh nvarchar(10),
  @diaChi nvarchar(50),
  @ngayBatDau varchar(10)
AS
BEGIN
  DECLARE @userID varchar(100)
  DECLARE @hoVaTenMoi varchar(500)
  SET @hoVaTenMoi= dbo.fnConvertToUnsignedVarchar(@hoVaTen)
  -- Lấy vị trí dấu cách cuối
  DECLARE @pos INT = CHARINDEX(' ', REVERSE(@hoVaTenMoi));
  SET @userID = @maThanhVien + '.' + UPPER(SUBSTRING(@hoVaTenMoi, LEN(@hoVaTenMoi) - @pos + 2, LEN(@hoVaTenMoi))) + '.' + @SDT;

  IF (EXISTS (SELECT *
  FROM NhanSu
  WHERE maThanhVien = @maThanhVien))
		BEGIN
    PRINT N'Nhân sự đã tồn tại'
    RETURN -1
  END
	ELSE
		INSERT INTO NhanSu
  VALUES
    (
      @maThanhVien,
      @matKhau,
      @hoVaTen,
      @userID,
      @SDT,
      @namSinh,
      @CCCD,
      @email,
      @nghiViec,
      @anhDaiDien,
      @laQuanLi,
	  @gioiTinh,
	  @diaChi,
	  @ngayBatDau
		)
  IF (@loaiNhanSu = N'Nhân viên')
		BEGIN
    INSERT INTO NhanVien (laTruongNhom,maThanhVien,maPB)
    VALUES 
      (0, @maThanhVien, @maPB)
    RETURN 0
  END
  IF (@loaiNhanSu = N'Quản lý')
		BEGIN
    INSERT INTO QuanLi
    VALUES
      (@maThanhVien, @hoVaTen)
	INSERT INTO NhanVien (laTruongNhom,maThanhVien,maPB,laQuanLi)
    VALUES 
      (0, @maThanhVien, @maPB,1)
    UPDATE NhanSu SET laQuanLi = 1 WHERE maThanhVien = @maThanhVien
    RETURN 0
  END
  IF (@loaiNhanSu = N'CEO')
		SET @maThanhVien = 'GD-001'
  BEGIN
    INSERT INTO CEO
    VALUES
      (@maThanhVien, @hoVaTen)
    RETURN 0
  END
END
GO

-- Function tìm mã quản lý của phòng ban bất kì
CREATE FUNCTION timQuanLy(@maPB VARCHAR(10))
RETURNS VARCHAR(10) AS
BEGIN
	DECLARE @maQuanLy VARCHAR(10)
	IF (NOT EXISTS (SELECT *
	FROM PhongBan
	WHERE maPB = @maPB))
		RETURN ''
	SELECT @maQuanLy = maThanhVien
	FROM QuanLi
	WHERE SUBSTRING(maThanhVien, 0, 3) LIKE @maPB
	RETURN @maQuanLy
END
GO

PRINT DBO.timQuanLy('VS')

-- Thêm 2 cột chế độ (public, private) và tên công việc
ALTER TABLE GiaoViec ADD cheDo BIT
ALTER TABLE GiaoViec ADD tenCongViec NVARCHAR(200)

EXEC taoViec N'Hello', '20240326', '20240329', N'Chưa hoàn thành', 'Hello',
 'GD-001.013', 'AN-401', 0, N'Kiểm tra an ninh', 1, 'GD-001'
delete from GiaoViec where maGiaoViec = 'GD-001.013'
delete from NhanViec where maGiaoViec = 'GD-001.013'
-- Bổ sung insert anh bạn quản lý bị không có tên trong nhân viên
select * from NhanVien
insert NhanVien
	(laTruongNhom,maThanhVien,maPB,maNhom)
values(1, 'VS-301', 'VS', 'N-003')
insert NhanVien
	(laTruongNhom,maThanhVien,maPB,maNhom)
values(1, 'KT-501', 'VS', 'N-004')

SELECT *
FROM GiaoViec
SELECT *
FROM NhanViec
SELECT *
FROM QuanLi
SELECT * FROM NhanVien	
SELECT * FROM KhuVucLamViec
EXEC taoViec N'Kiểm tra vì hòa bình thế giới', '20240310', '20240317', N'Đang tiến hành', 'D:\CTU\Dangki.html',
 'GD-001.002', 'KT-501', 0, N'Kiểm tra tình hình khu vực Ostania', 1, 'GD-001'
DELETE FROM NhanViec WHERE maGiaoViec = 'GD-001.015'
DELETE FROM GiaoViec WHERE maGiaoViec = 'GD-001.015'

