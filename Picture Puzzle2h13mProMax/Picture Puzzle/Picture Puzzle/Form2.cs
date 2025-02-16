using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Collections;
using System.IO;

namespace Picture_Puzzle
{
    public partial class Form2 : Form
    {
        Point EmptyPoint;
        ArrayList images = new ArrayList();
        public Form2()
        {
            EmptyPoint.X = 270;
            EmptyPoint.Y = 270;
            InitializeComponent();
        }
        private void AddImagesToButtons(ArrayList images)
        {
            int i = 0;
            int[] arr = { 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 };

            arr = suffle(arr);

            foreach (Button b in panel1.Controls)
            {
                if (i < arr.Length)
                {
                    b.Image = (Image)images[arr[i]];
                    i++;
                }
            }
        }
        private int[] suffle(int[] arr)
        {
            Random rand = new Random();
            arr = arr.OrderBy(x => rand.Next()).ToArray();
            return arr;
        }
        private void cropImageTomages(Image orginal, int w, int h)
        {
            Bitmap bmp = new Bitmap(w, h);

            Graphics graphic = Graphics.FromImage(bmp);

            graphic.DrawImage(orginal, 0, 0, w, h);

            graphic.Dispose();

            int movr = 0, movd = 0;

            for (int x = 0; x < 16; x++)
            {
                Bitmap piece = new Bitmap(90, 90);

                for (int i = 0; i < 90; i++)
                    for (int j = 0; j < 90; j++)
                        piece.SetPixel(i, j, bmp.GetPixel(i + movr, j + movd));

                images.Add(piece);

                movr += 90;

                if (movr == 360)
                {
                    movr = 0;
                    movd += 90;
                }
            }
        }

        private void MoveButton(Button btn)
        {
            if (((btn.Location.X == EmptyPoint.X - 90 || btn.Location.X == EmptyPoint.X + 90)
                && btn.Location.Y == EmptyPoint.Y)
                || (btn.Location.Y == EmptyPoint.Y - 90 || btn.Location.Y == EmptyPoint.Y + 90)
                && btn.Location.X == EmptyPoint.X)
            {
                Point swap = btn.Location;
                btn.Location = EmptyPoint;
                EmptyPoint = swap;
            }

            if (EmptyPoint.X == 180 && EmptyPoint.Y == 180)
                CheckValid();
        }
        private void CheckValid()
        {
            int count = 0;
            int index;

            foreach (Button btn in panel1.Controls)
            {
                index = (btn.Location.Y / 90) * 4 + btn.Location.X / 90;
                if (images[index] == btn.Image)
                    count++;
            }

            if (count == 15)
            {
                isGameInProgress = false;
                timer1.Enabled = false;
                int minutes = elapsedSeconds / 60;
                int seconds = elapsedSeconds % 60;
                string completionTime = string.Format("{0:00}:{1:00}", minutes, seconds);
                MessageBox.Show("Chúc mừng bạn đã thắng!\nVới thời gian: " + completionTime);
            }
        }
        private int elapsedSeconds = 0;
        private bool isGameInProgress;

        //t được tăng lên một.
        
        private void UpdateTimerLabel()

        {
            //phép chia số giây
            int minutes = elapsedSeconds / 60;
            int seconds = elapsedSeconds % 60;
            //được hiển thị cho người chơi.
            label1.Text = string.Format("{0:00}:{1:00}", minutes, seconds);
        }

        private void Form2_Load(object sender, EventArgs e)
        {

        }

        private void button1_Click(object sender, EventArgs e)
        {
            MoveButton((Button)sender);
        }

        private void button9_Click(object sender, EventArgs e)
        {
            foreach (Button b in panel1.Controls)
                b.Enabled = true;



            // Tạo một đối tượng ngẫu nhiên để chọn số
            Random random = new Random();

            // Sinh một số ngẫu nhiên từ 1 đến 10
            int randomNumber = random.Next(1, 11);

            // Xây dựng tên tập tin ảnh từ số ngẫu nhiên
            string imageFileName = randomNumber.ToString() + ".jpg";

            // Tạo đường dẫn đầy đủ đến tập tin ảnh
            string imagePath = Path.Combine("img", imageFileName);
            if (File.Exists(imagePath))
            {
                // Tạo đối tượng hình ảnh từ tập tin
                Image orginal = Image.FromFile(imagePath);
                pictureBox1.SizeMode = PictureBoxSizeMode.StretchImage;
                pictureBox1.Image = orginal;


                images.Clear();
                cropImageTomages(orginal, 360, 360);


                AddImagesToButtons(images);
            }
            // Start the timer
            timer1.Enabled = true;
            elapsedSeconds = 0;
            UpdateTimerLabel();
        }

        private void timer1_Tick_1(object sender, EventArgs e)
        {
            elapsedSeconds++;//tăng lên
            UpdateTimerLabel();//thêm thời gian
        }

        private void button17_Click(object sender, EventArgs e)
        {
            // Tạo một instance của Form2
            Form1 form1 = new Form1();

            // Hiển thị Form2
            form1.Show();

            // Đóng Form1 (tùy chọn)
            this.Hide();
        }
    }
}
